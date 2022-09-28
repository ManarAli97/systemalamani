<script>
    var table;
    $(document).ready(function() {

        var selected = [];

        table =  $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_quantity2",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 0, 'asc'] ],
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
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    
         $('button.toggle-vis').on('click', function (e) {
            e.preventDefault();

            // Get the column API object
            var column = table.column($(this).attr('data-column'));

            // Toggle the visibility
            column.visible(!column.visible());
        });

    
    
    } );
</script>



<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl($this->folder) ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > excel export 2   </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="row">
    <div class="col">
    <div>
           <span> اخفاء / اظهار  </span>: <button class="btn btn-primary  toggle-vis" data-column="0"> نوع الجهاز </button> -
            <button class="btn btn-primary toggle-vis" data-column="1">اسم الحافظة</button> -
            <button class="btn btn-primary toggle-vis" data-column="2">الباركود</button> -
            <button class="btn btn-primary toggle-vis" data-column="3">الكمية</button> -
            <button class="btn btn-primary toggle-vis" data-column="4"> الاسم الاتيني </button> -
            <button class="btn btn-primary toggle-vis" data-column="5">صورة</button> -
            <button class="btn btn-primary toggle-vis" data-column="6">تاريخ</button>
        </div>
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>


                <th>   نوع الجهاز  </th>
                <th> اسم الحافظة </th>
                <th> الباركود </th>
                <th> الكمية </th>
                <th>  الاسم الاتيني </th>
                <th>  صورة </th>

                <th> تاريخ   </th>


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



<script>


    function visible_savers_location(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_savers_location/"+vis+'/'+id, function(data){

            if (vis === 1)
            {
                $(".location_active_"+id).html(`<span   style='color: green;font-weight: bold'>ON</span>`)
            }else
            {
                $(".location_active_"+id).html(`<span   style='color: red;font-weight: bold'>OFF</span>`)

            }

            table.draw()

        })
    }



</script>


