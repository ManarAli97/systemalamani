

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('qr_mte') ?> </a></li>
                <li class="breadcrumb-item"> تقرير موظفين الصيانة </li>
            </ol>
        </nav>

    </div>

</div>



<script>



    var table;
    $(document).ready(function() {

        var selected = [];
         table = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_report",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[2]);
            },
            "order": [[ 2, 'desc'] ],
            aLengthMenu: [ 100,  200,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
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


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">  اسم الزبون   </th>
        <th scope="col">   رقم الهاتف  </th>
        <th scope="col">    الوقت  </th>
        <th scope="col">     الموظف  </th>
    </tr>
    </thead>
</table>


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
<br>

