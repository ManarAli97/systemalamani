




<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_excel_compare/<?php echo $model ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[0]);
            },
            // "order": [[ 0, 'desc'] ],
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
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/excel_compare/<?php echo $model ?>"><?php  echo $this->langControl('excel') ?> </a></li>

                    <li class="breadcrumb-item active" aria-current="page" > مقارنة الكميات </li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php echo $this->langControl($model)  ?> </li>
                 </ol>
            </nav>


            <hr>
        </div>
    </div>


<?php  if ($this->permit('convert_and_quantity_adjustment', 'material_inventory')) {  ?>

<div class="row align-items-center">
    <div class="col-auto  mb-3">
        <input style="width: 150px" type="text" name="code" placeholder="رمز المادة" id="code_one_mater"  class="form-control" data-toggle="tooltip"   title="في حال اضافة رمز مادة يكون التحويل فقط لرمز المادة المدخل">
    </div>
    <div class="col-auto mb-3">
        <div class="custom-control custom-checkbox">
            <input  type="checkbox"  name="one"  class="custom-control-input" value="1" id="customCheck-one">
            <label class="custom-control-label" for="customCheck-one" style="font-size: 13px;"> تحول الكمية الزايده من excel الى مواد بنتظار تأكيد مواقعها  </label>
        </div>
    </div>
    <div class="col-auto mb-3">
        <div class="custom-control custom-checkbox">
            <input type="checkbox"  name="two"  class="custom-control-input" value="1" id="customCheck-two">
            <label class="custom-control-label" for="customCheck-two" style="font-size: 13px;"> تحول الكمية الزايده في مواد بنتظار تأكيد مواقعها و المواقع الى excel </label>
        </div>
    </div>
    <div class="col-auto mb-3">
        <div class="custom-control custom-checkbox">
            <input type="checkbox"  name="three"  class="custom-control-input" value="1" id="customCheck-three">
            <label class="custom-control-label" for="customCheck-three" style="font-size: 13px;">   حذف الكميات الزائدة في اكسيل كميات واسعار عن الموقع </label>
        </div>
    </div>
    <div class="col-auto mb-3">
        <button onclick="start_convert()"  class="btn btn-warning btn_progress_set_qu" data-toggle="tooltip" data-html="true" title="<span>1-نقل الكمية من اكسيل كميات واسعار الى مواد بأنتظار تأكيد مواقعها في حال الكمية اكبر من كمية المواقع </span><br><span>2-نقل الكمية من المواقع الى اكسيل كميات واسعار دون تحويلها الى مواد بأنتظار تأكيد مواقعها في حال كمية المواقع اكبر من الكمية الكلية</span> "  >  <span> تعديل اختلاف الكميات </span>   </button>
        <a   class="btn btn-primary  "   href="<?php  echo  url .'/'.  $this->folder?>/track" >  <span>  تقرير التعديل   </span>   </a>

    </div>
</div>

<div class="progress mt-3 progress_set_qu" style="display: none">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
</div>
<script>

    function start_convert() {

     if (confirm('هل انت متأكد ؟ ')) {

         var code=$('#code_one_mater').val();

         var one=0;
         if ($('#customCheck-one:checked').val())
         {
               one=$('#customCheck-one:checked').val();
         }

         var two=0;

         if ($('#customCheck-two:checked').val())
         {
           two=$('#customCheck-two:checked').val();
         }

         var three=0;

         if ($('#customCheck-three:checked').val())
         {
             three=$('#customCheck-three:checked').val();
         }


    $('.btn_progress_set_qu').attr('disabled', "disabled")
    $('.progress_set_qu').show()
    $.get("<?php echo url . '/' . $this->folder ?>/start_convert", {model: '<?php   echo $model ?>',code:code,one:one,two:two,three:three}, function (data) {

        console.log(data)

        if (data ==='true') {
            $('.btn_progress_set_qu').removeAttr('disabled')
            $('.progress_set_qu').hide()
            alert('انتهت العملية')
           // window.location = ''
        }else
        {
            alert('حدث خطأ اعد المحاوله ')
        }

    });
       }return false

    }


</script>

<?php  } ?>



<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th> رمز المادة </th>
                    <th> الكمية الكلية  </th>
                    <th>   كمية مواقع المادة (الجرد)  </th>
                    <th>  المواقع    </th>

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




