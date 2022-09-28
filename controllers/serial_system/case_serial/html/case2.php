

<script>
    var table;
    $(document).ready(function() {


          table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_serial_over_enter_quantity",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 1, 'asc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            orderCellsTop: true,
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








    function  delete_serial_over_enter_quantity(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/delete_serial_over_enter_quantity/"+id, function(data){
                if (data)
                {
                    table.draw()
                }
            })
        }return false;


    }


</script>


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/serial_over_enter_quantity"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl('serial_over_enter_quantity') ?>   </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>




<table  id="example" class="table table-striped display d-table"  >
    <thead>
    <tr>
        <th>  رقم الصقحة </th>
        <th> القسم </th>
        <th>  الباركود </th>
        <th>   السيريال  </th>
        <th>  رقم الفاتورة </th>
        <th>  الموقع </th>
        <th> المستخدم </th>
        <th>تاريخ والوقت </th>
        <th> حذف </th>


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

    .table_location
    {
        background: #ffffFF;
        width: max-content;
    }
    .table_location tr td
    {
        padding: 0;
        background: #ffffFF;
        border: 1px solid #d4d1d1;
    }


    .table_location tr td span
    {
        font-weight: bold;
        background: transparent;
        color: #000;
        padding: 0;
        font-size: 18px;
    }

</style>













