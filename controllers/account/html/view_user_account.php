
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
<br>

<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
                <tr>
                    <th> الاسم </th>
                    <th> رقم الهاتف  </th>
                    <th>  النوع </th>
                    <th> الفرع  </th>
                    <th>  اسم المستخدم</th>
                    <th> التاريخ</th>
                    <th>التعديل </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php  echo $id?>",
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
    });









</script>



<style>

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