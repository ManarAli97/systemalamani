


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('sales_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('report') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



    <form action="<?php  echo  url .'/'.$this->folder ?>/report" method="get">
        <div class="form-group row">
            <div class="col-auto">
                <input type="date" class="form-control" name="date"   value="<?php  if ($date) echo date('Y-m-d',$date) ?>"    required>

            </div>
            <div class="col-auto">
                <button class="btn btn-info" type="submit" >بحث</button>
            </div>
        </div>
    </form>




<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report/<?php  echo $date ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[11]);
            },
            "order": [[ 1, 'desc'] ],
            'columnDefs': [{
                "targets": [0],
                "orderable": false
            }],

            aLengthMenu: [ 50,100, 200, 300,-1],
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


            },dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>


<hr>
 <div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>  <input type='checkbox'   class="checkall"  >  </th>
                <th>القسم</th>
                <th>اسم المادة</th>
                <th>كود</th>
                <th>اللون</th>
                <th>سعر بالدينار</th>
                <th>الكمية المطلوبة</th>
                <th>ملاحظة</th>
                <th>التاريخ</th>
                <th>صورة</th>
                <th>الموظف</th>
            </tr>
            </thead>

        </table>

    </div>
</div>



<script>

    $(function(){
        $('.checkall').on('click', function() {
            $('.childcheckbox').prop('checked', this.checked)
        });
    });


    $(function() {
        $("#convert_to_employ_purchases").submit(function (e) {
            e.preventDefault();
            var actionurl = e.currentTarget.action;
            $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#convert_to_employ_purchases").serialize(),
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.done) {
                        for (var prop in response.done) {
                            $('#row_'+response.done[prop]).remove();
                        }
                        alert('تم التحويل')
                    }
                    else if (response.empty)
                    {
                        alert('يرجى تحديد او اضافة نواقص الى القائمة')
                    }
                }
            })

        });
    });


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

<br>
<br>
<br>








