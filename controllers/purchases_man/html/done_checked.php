


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('purchases_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >مشتريات مدققة </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



<form action="<?php  echo  url .'/'.$this->folder ?>/report_purchases" method="get">
    <div class="form-group row">
        <div class="col-auto">
            <input type="date" class="form-control" name="date"   value="<?php  if ($date) echo date('Y-m-d',$date) ?>"    required>

        </div>
        <div class="col-auto">
            <button class="btn btn-info" type="submit" >بحث</button>
        </div>
    </div>
</form>


<form id="checked_purchases_all"   method="post">


    <?php  foreach ($categ as $catx ) { ?>

    <br>
    <br>
    <h2> <?php echo $this->langControl($catx)  ?> </h2>
    <script>
        $(document).ready(function() {

            var selected = [];

            $('#example<?php  echo $catx ?>').DataTable( {
                scrollY:        "500px",
                scrollX:        true,
                scrollCollapse: true,
                serverSide:     true,
                fixedColumns:false,
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_done_checked/<?php  echo $catx ?>/<?php  echo $date ?>",
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id','row_'+ aData[15]);
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


        <hr>
        <div class="row">
            <div class="col">
                <div class="dataTables_wrapper">

                    <table  id="example<?php  echo $catx ?>" class="table table-striped display d-table stripe row-border order-column"  >
                        <thead>
                        <tr>
                            <th>  <input type='checkbox'   class="checkall" >  </th>
                            <th>تم التدقيق</th>
                            <th>القسم</th>
                            <th>اسم المادة</th>
                            <th>  نوع المشتريات </th>
                            <th>كود</th>
                            <th>اللون</th>
                            <th>سعر اخر شراء</th>
                            <th>الكمية المطلوبة</th>
                            <th>الكمية تم شرائها</th>
                            <th>  باقي الكمية </th>
                            <th>ملاحظة</th>
                            <th>التاريخ</th>
                            <th>صورة</th>
                            <th>المندوب</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>






        <div class="row justify-content-center">
        <div class="col-auto ">
            <input class="btn btn-danger"  name="submit"  value="الغاء التدقيق"  type="submit">
        </div>
    </div>

        <script>

            $(function(){
                $('.checkall<?php  echo $catx ?>').on('click', function() {
                    $('.childcheckbox<?php  echo $catx ?>').prop('checked', this.checked)
                });
            });


        </script>

        <hr>
    <?php }  ?>

</form>






<script>



    function checked_purchases(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder?>/checked_purchases/"+vis+'/'+id, function(){ })
    }



    $(function() {
        $("#checked_purchases_all").submit(function (e) {

            if (confirm("هل انت متاكد؟")) {

                e.preventDefault();
                var actionurl = e.currentTarget.action;
                $.ajax({
                    url: "<?php  echo url . '/' . $this->folder ?>/note_checked_purchases_all",
                    type: 'post',
                    cache: false,
                    data: $("#checked_purchases_all").serialize(),
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response.done) {
                            for (var prop in response.done) {

                                $('#checked_' + response.done[prop]).bootstrapToggle('off')
                            }
                            alert('تم الغاء التدقيق');
                        } else if (response.error_ch) {
                            alert('يرجى تحديد فقط المشتريات التي لم يتم تحديدها')
                        } else if (response.empty) {
                            alert('فشل يرجى المحاولة لاحقا')
                        }
                    }
                })

            }else
            {
                return false;
            }

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
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: auto;
        margin: 0 auto;
    }

    th,
    td {
        padding-left: 40px !important;
        padding-right: 40px !important;
    }
</style>

<br>
<br>
<br>








