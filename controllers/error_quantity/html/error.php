
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('error_quantity') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" >   اخطاء  كميت المواقع </li>

            </ol>
        </nav>
        <hr>
    </div>
</div>


<script>
    var  table;
    $(document).ready(function() {

        var selected = [];
        table =    $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_filter_location_error_quantity",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            } ,
            "order": [[ 8, 'desc'] ],
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
        } );
    } );
</script>


<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">    القسم </th>
        <th scope="col"> رمز المادة </th>
        <th scope="col">  الموقع   </th>
        <th scope="col">    الكمية  </th>
        <th scope="col">    النوع  </th>
        <th scope="col">    الملاحظة   </th>
        <th scope="col">    رقم الفاتورة   </th>
        <th scope="col">    المستخدم   </th>
        <th scope="col">    التاريخ    </th>
        <th scope="col">    معالجة الخظأ برمجيا   </th>
        <th scope="col">    معالجة الكمية    </th>
    </tr>
    </thead>
</table>

<script>

    function error_location_correcting(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/error_location_correcting/"+id, function(data){
                if (data)
                {

                    table.draw()

                }
            })
        }

    }

    function error_location_correcting_data(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/error_location_correcting_data/"+id, function(data){

                console.log(data)
                if (data)
                {

                    table.draw()

                }
            })
        }

    }


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
<br>
