

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('log_accountant') ?> </a></li>
                <li class="breadcrumb-item">  عرض الفواتير  </li>
                <li class="breadcrumb-item">   <?php  echo $result['username'] ?>  </li>
            </ol>
        </nav>

    </div>

</div>


<div class="alert alert-danger" role="alert">
    <strong> <span>  المجموع الكلي للفواتير : </span> <span><?php echo  $result['money'] ?></span>   د.ع </strong>
</div>



<div class="alert alert-warning" role="alert">
    <strong> <span> باقي في ذمة الموظف (مجوع الفواتير + المبلغ المضاف من القاصة - المبلغ المسحوب): </span> <span><?php echo $result['remainder']  ?></span>  د.ع </strong>
</div>


<script>
    $(document).ready(function() {

        var selected = [];
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_bill/<?php echo $id ?>",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[5]);
            },

            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            }
            ,
            "columnDefs": [
                { className: "title_cell", "targets": [ 0 ] },
            ]
        } );
    } );
</script>


<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col"> رقم الفاتورة </th>
        <th scope="col">   مجموع الفاتورة  </th>
        <th scope="col">  المحاسب </th>
        <th scope="col">  التاريخ   </th>
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











