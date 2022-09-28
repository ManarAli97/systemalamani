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


<br>
<div class="search">
    <div class="form-row row mb-4">

        <div class="col-lg-2 col-md-2 mb-4">
            <label class="mr-sm-2" for="depart">اختر قسم الفاتورة</label>
            <select name="depart" class=" dropdown_filter selectpicker" data-live-search="true"  id="depart" required >
                <option value="select">اختر القسم</option>
                <?php foreach ($this->category_website as $key => $value) {   ?>
                    <option value="<?=$key?>"><?= $value?></option>
                <?php  } ?>
            </select>
        </div>
        <div class="col-lg-1 col-md-2 mb-4">
          <button type="button" class="btn btn-sm btn-primary" onclick="" id="search"> <?php  echo $this->langControl('search') ?></button>
        </div>
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
                <th> حالة الطلب</th>
                <th> تاريخ الطلب</th>
                <th>  تعديل </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#search').on('click', function(e) {
            // var  state =" ";

            // var date_start = $('#date_start').val();
            // if(date_start == ''){
            //     date_start = 0;
            // }
            // var date_end = $('#date_end').val();
            // if(date_end == ''){
            //     date_end =0;
            // }

            // $.each($("input[name='state']:checked"), function(){
            //     state +=  "' " + $(this).val() + " ',";
            // });
            // state = state.slice(0,-1);
            // console.log(state);

            var model = $("#depart").val();
            // console.log(model);
            var table = $('#example').DataTable();
            table.destroy();
            $('#example').DataTable( {
                // scrollCollapse: true,
                // scrollX: "100%",
                // responsive: true,
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_reminder_purchase/"+model,
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
                bFilter: true,
                bInfo: true,

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
        margin: 34px ;
        width: 50px;
        color: #fff;
        border-radius: 6px;
        padding: 5px 5px;
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


















