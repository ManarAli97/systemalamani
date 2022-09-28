<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('report_purchase') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<div class="col-lg-2 col-md-2 mr-4">
    <a href="<?php  echo url.'/'.$this->folder?>/add_purchase_bill" class="btn btn-primary btn-sm"> <?php  echo $this->langControl('purchase_bill') ?> <i class="fa fa-plus"></i></a>
</div>

<br>
<div class="search">
    <div class="form-row row mb-4">
        <div class="col-lg-2 col-md-1  mb-4 mr-2">
            <label class="mr-sm-2" for="date_start"> من </label>
            <input type="date" name="date_start"  class="form-control" id="date_start">
        </div>
        <div class="col-lg-2 col-md-1 mb-4 mr-2">
            <label class="mr-sm-2" for="date_end">  الى </label>
            <input type="date" name="date_end"  class="form-control" id="date_end">
        </div>

        <div class="col-lg-2 col-md-2 mb-4 mr-4">
                    <label class="mr-sm-2" for="depart">اختر قسم الفاتورة</label>
                    <select name="depart" class=" dropdown_filter selectpicker" data-live-search="true"  id="depart" required >
                        <option value="select">اختر القسم</option>
                        <?php foreach ($this->category_website as $key => $value) {   ?>
                            <option value="<?=$key?>"><?= $value?></option>
                        <?php  } ?>
                    </select>
                </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"     value="on_request" id="on_request" class="custom-control-input"  >
                <label class="custom-control-label" for="on_request"> قيد الطلب </label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"     value="being_processed" id="being_processed" class="custom-control-input"  >
                <label class="custom-control-label" for="being_processed"> قيد التجهيز </label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"     value="being_sent" id="being_sent" class="custom-control-input"  >
                <label class="custom-control-label" for="being_sent">  قيد الارسال </label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"    value="shipping" id="shipping" class="custom-control-input"  >
                <label class="custom-control-label" for="shipping">  قيد الشحن </label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"    value="loaded" id="loaded" class="custom-control-input"  >
                <label class="custom-control-label" for="loaded">  محملة </label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"       value="arrival" id="arrival" class="custom-control-input"  >
                <label class="custom-control-label" for="arrival">  تم الوصول </label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"     value="arrival_warehouse" id="arrival_warehouse" class="custom-control-input"  >
                <label class="custom-control-label" for="arrival_warehouse">  داخلة بمخازننا </label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"    name="state"     value="receive" id="receive" class="custom-control-input"  >
                <label class="custom-control-label" for="receive">   واصلة  </label>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-1 mb-4 mr-2">
        <button type="button" class="btn btn-sm btn-primary" onclick="" id="search"> <?php  echo $this->langControl('search') ?></button>
            <!-- <input class="btn btn-primary" id="search" value="<?php  echo $this->langControl('search') ?>" > -->
    </div>

</div>

<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> التسلسل </th>
                <th> المصدر  </th>
                <th> اسم المستخدم </th>
                <th>تاريخ دخول البضاعة لمخزن الشركة</th>
                <th>  رقم فاتورة كرستال </th>
                <th> تم الوصول للمخزن  </th>
                <th>  رفع تراكمي   </th>
                <th>  حالة الطلب   </th>
                <th> تاريخ الطلب</th>
                <th>  تعديل </th>
                <th> تكرار </th>
                <th> رفع اكسل </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#search').on('click', function(e) {
            var  state =" ";

            var date_start = $('#date_start').val();
            if(date_start == ''){
                date_start = 0;
            }
            var date_end = $('#date_end').val();
            if(date_end == ''){
                date_end =0;
            }

            $.each($("input[name='state']:checked"), function(){
                state +=  "' " + $(this).val() + " ',";
            });
            state = state.slice(0,-1);
            console.log(state);

            var model = $("#depart").val();
            console.log(model);
            var table = $('#example').DataTable();
            table.destroy();
            $('#example').DataTable( {
                // scrollCollapse: true,
                // scrollX: "100%",
                // responsive: true,
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_purchase/"+date_start+"/"+date_end+"/"+model+"/"+state,
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id','row_'+ aData[7]);
                },

                'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }],

                aLengthMenu: [ 50,100, 200, 300,-1],
                oLanguage: {
                    sLoadingRecords: "تحميل ...",
                    sProcessing: " معالجة ...",
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
                bFilter: true, bInfo: true,

            });
            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column( $(this).attr('data-column') );

                // Toggle the visibility
                column.visible( ! column.visible() );

            });
        });

    });

    function receive_products(id){
        var bill_crystall = $('#bill_crystal_'+id).val();
        console.log(bill_crystall);
        if(bill_crystall != ''){
            $.get("<?php  echo url.'/'.$this->folder?>/receive_products/"+id+"/"+bill_crystall, function(data){
            console.log(data);
            if (data == 1)
            {
                $('#example').DataTable().ajax.reload();
            }

        });

        }else{
            alert('الرجاء ادخال رقم فاتورة كرستال');
        }
    }

    function add_to_excel(id) {
        var bill_crystal = $('#bill_crystal_'+id).val();
        console.log(bill_crystal);
        if(bill_crystal != ''){
            $.get("<?php  echo url.'/'.$this->folder?>/add_to_excel/"+id+"/"+bill_crystal, function(data){
                console.log(data);
                if (data == 1)
                {
                    $('#example').DataTable().ajax.reload();
                }

            });

        }else{
            alert('الرجاء ادخال رقم فاتورة كرستال');
        }

    }

    function copy_row(id){
        if (confirm('هل انت متأكد؟'))
        {
            // var table = $('#example').DataTable();
            $.get("<?php  echo url.'/'.$this->folder?>/copy_row/"+id, function(data)
            {
                if (data)
                {
                    alert('تم التكرار');
                    $('#example').DataTable().ajax.reload();
                }
            });
        }

    }


</script>






<style>
    .breadcrumb{
        border-radius: 0 !important;
        margin-bottom: 0 !important;
        background-color: rgba(121,169,197,.92) !important;
        -webkit-box-shadow: 0px -4px 3px #ccc;
        -moz-box-shadow: 0px -4px 3px #ccc;
        box-shadow: 0px -4px 10px #ccc;
    }
    .breadcrumb li {
        color: #fff !important;
    }
    #search{
        /* position: relative; */
        text-align: center;
        justify-self: center;
        margin: 34px auto;
        width: 100px;
        /* background-color: #00a65a; */
        color: #fff;
        border-radius: 6px;
        padding: 5px 10px;
    }
   .d-table
    {
        width:100%;
        margin-top:30px !important;
        border: 1px solid #c4c2c2;
        border-radius: 5px;

    }
    table thead tr
    {


        white-space: nowrap;
        background-color: rgba(121,169,197,0.92) !important;
        color: #fff;
        text-align: center;

    }
    table tbody tr td
    {
     text-align: center;
       white-space: nowrap;
        /* height : 50px !important; */
        font-size:16px;
    }
    table tbody  tr:nth-child(odd) {
        background-color: #f8f9fa !important;
    }
    table tbody  tr:nth-child(even) {
        background-color: #f3f8fa;
    }

</style>


<br>
<br>
<br>


















