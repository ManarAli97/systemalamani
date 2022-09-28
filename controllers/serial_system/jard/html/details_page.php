

<script>
    $(document).ready(function() {


        var table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_details_pagejard/<?php  echo $id ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 10, 'desc'] ],
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
</script>


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_jard"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > تقرير الجرد  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $id ?>  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">

    <div class="col-auto">
        <button  role="button"  onclick="creat_page_jard()"   class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> انشاء صفحة </span> </button>
        <a href="<?php echo  url.'/'.$this->folder ?>/list_jard"  class="btn btn-warning btn-sm">رجوع</a>

    </div>

</div>

<script>

    function creat_page_jard() {
        if (confirm('انشاء صفحة جديدة ؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder?>/creat_page_jard", function( data ) {
                console.log(data)
                window.location="<?php echo url .'/'.$this->folder?>/add_jard/"+data
            });
        }return false

    }

</script>


<hr>



        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> رقم  الجرد </th>
                <th> القسم  </th>
                <th> الفئة  </th>
                <th>اسم المادة</th>
                <th>  رمز المادة  </th>

                <th> كمية الواقع </th>
                <th> كمية  المواقع عند جرد السيريال </th>
                <th>    الكمية الحالية  </th>
                <th>    نوع الادخال </th>
                <th> المستخدم </th>
                <th>تاريخ والوقت </th>


            </tr>
            </thead>

        </table>


<script>

    function get_serial_jard_details(code,model,page) {

        $.get("<?php  echo url.'/'.$this->folder?>/get_serial_jard_details/"+code+'/'+model+'/'+page, function(data){
            if (data)
            {
                $('#data_collapse_'+code+model).html(data)
            }
        })
    }

    function get_all_location_jard_details(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/get_all_location_jard_details/"+code+'/'+model, function(data){
            if (data)
            {
                $('#location_data_collapse_'+code+model).html(data)
            }
        })
    }
    function get_serial(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/get_serialWithOutDelete/"+code+'/'+model, function(data){
            if (data)
            {
                $('#data_collapse_Serial'+code+model).html(data)
            }
        })
    }
</script>
<style>
    .list_serial {
        border-bottom: 1px solid #dfdfdf;
        position: relative;
    }
    .list_serial:last-child {
        border-bottom: 0;
    }

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



<script>

    function active_serial_system(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php  echo url.'/'.$this->folder?>/active_serial_system/"+vis+'/'+id, function(data){
           if (data !== 'true')
           {
               window.location="<?php  echo url ?>/login/user"
           }
        })
    }

</script>




<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php echo $this->langControl('delete') ?> </button>
            </div>
        </div>
    </div>
</div>



<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        console.log(id)
        $.get( "<?php echo url .'/'. $this->folder ?>/delete_serial_system/"+id, function( data ) {
            if (data === 'true') {
                $('#row_' + id).remove();
                $('#exampleModal').modal('hide')
            }else
            {
                window.location="<?php  echo url ?>/login/user"
            }
        });
    });
</script>








