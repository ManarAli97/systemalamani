

<script>
    var table;
    $(document).ready(function() {


          table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,

              <?php  if ($model=='accessories'){ ?>
              "ajax": "<?php echo url .'/'.$this->folder ?>/processing_serial_material_inventory_accessories/<?php  echo $model ?>/<?php  echo $id ?>",
              <?php  }else if ($model=='savers')  { ?>
              "ajax": "<?php echo url .'/'.$this->folder ?>/processing_serial_material_inventory_savers/<?php  echo $model ?>/<?php  echo $id ?>",
              <?php  }else{   ?>
              "ajax": "<?php echo url .'/'.$this->folder ?>/processing_serial_material_inventory/<?php  echo $model ?>/<?php  echo $id ?>",
              <?php  } ?>

            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 3, 'desc'] ],
            aLengthMenu: [ -1, 10,25, 50, 100],
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
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_report_serial_entry"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >   السيريلات المعرفة  </li>
                <?php  echo $category ?>

            </ol>
        </nav>


        <hr>
    </div>
</div>




<form action="<?php  echo  url .'/'.$this->folder ?>/serial_material_inventory" method="get">
    <div class="container-fluid" id="expand_menu">
        <div class="row">

            <select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx()" required>
                <option value="" disabled selected>  اختر الفئة الرئيسية  </option>
                <?php  foreach ($this->category_website as $key => $cg) {   ?>
                    <option   <?php  if ($key == $model) echo 'selected' ?>  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                <?php  } ?>
            </select>

            <div class="col-auto">
                <button class="btn btn-info" type="submit" >   <span>بحث </span> <i class="fa fa-search"></i> </button>
            </div>

            <div class="col-auto">
                <button  type="button" role="button"  onclick="creat_page_jard()"   class="btn btn-primary "> <i class="fa fa-plus" aria-hidden="true"></i>  <span> انشاء صفحة </span> </button>
            </div>

        </div>

    </div>

</form>


<script>


    mainCatgHtmlx()
    function mainCatgHtmlx() {

        var value =$("#her_add_menu :selected").val();
        var id_html ='her_add_menu';

        if (value !== 'savers')
        {
            $.get("<?php echo url   ?>/location_report/getMainCatDB/" +value, function (data) {
                if (data)
                {
                    $('#'+id_html).nextAll('select').remove();
                    $('#'+id_html+':last').after(data);
                }
                else
                {
                    alert('حدث خطاء في الاختيار يرجى تحديث الصفة او المحاولة لاحقا')
                }
            });
            pathCatg();

        }else
        {
            $('#'+id_html).nextAll('select').remove();
        }

    }


    function sub_catgs(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;
        $.get("<?php echo url  ?>/location_report/sub_catgs/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function sub_catgs2(selectObject) {
        var value = selectObject.value;
        var id_html = selectObject.id;

        $.get("<?php echo url   ?>/location_report/sub_catgs2/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function pathCatg() {
        var d = $('#expand_menu select option:selected').map(function () {
            return $(this).text();
        });

        p=d[0];
        for (i = 1; i < d.length; i++)
        {
            p+=" / "+d[i];
        }
        $('#path_catg').val(p)
    }


</script>






<script>

    function creat_page_jard() {
        if (confirm('انشاء صفحة جديدة ؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder?>/creat_page_serial", function( data ) {
                console.log(data)
                window.location="<?php echo url .'/'.$this->folder?>/add_report_serial_entry/"+data
            });
        }return false

    }

</script>


<hr>


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>   القسم    </th>
                <th>  اسم المادة </th>
                <th>  رقم الفاتورة </th>
                <th>  رمز المادة  </th>
                <th>   الباركود البديل </th>
                <th>   اللون </th>
                <th>   الذاكرة </th>
                <th>    الكمية المضروبة </th>
                <th>    مواقع السيريالات  </th>
                <th> الكمية الحالية </th>
                <th  >  المواقع </th>

                <th>تاريخ والوقت </th>
                <th> تصحيح </th>
                <th>   حذف </th>


            </tr>
            </thead>

        </table>



<style>

    .btn_quantity_enter{
        padding: 1px 13px;
        font-size: 23px;
        font-weight: bold;
    }
   .btn_location{
        padding: 1px 13px;
        font-size: 23px;
        font-weight: bold;
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


    .table_serial_location
    {
        background: #ffffFF;

    }
    .table_serial_location tr td
    {
        padding: 0;
        background: #ffffFF;
        border: 1px solid #d4d1d1;
    }


    .table_serial_location tr td span
    {

        background: transparent;
        color: #000;
        padding: 0;

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

    function get_serial(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/get_serial/"+code+'/'+model, function(data){
           if (data)
           {
               $('#data_collapse_'+code+model).html(data)
           }
        })
    }

    function quantity_correction(e,code,model) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/quantity_correction/"+code+'/'+model, function(data){

                console.log(data)
                if (data==='true')
                {
                      table.draw()
                       $(e).html('<i class="fa fa-check-circle"></i>');

                }else if (data==='nolocation')
                {
                    alert('السيريلات لا تحتوي مواقع')
                }else
                {
                    alert( data)
                }
            })
        }

    }

    function get_location_serial(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/get_location_serial/"+code+'/'+model, function(data){
           if (data)
           {
               $('#location_serial_data_collapse_'+code+model).html(data)
           }
        })
    }

    function list_location(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/list_location/"+code+'/'+model, function(data){
           if (data)
           {
               $('#data_location_'+code+model).html(data)
           }
        })
    }

    function  delete_serial(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/delete_serial/"+id, function(data){
                if (data==='true')
                {
                    $('#serial_'+id).remove()
                }else
                {
                    alert('لا يمكن حذف السيريال تم بيعة')
                }
            })
        }return false;


    }


    function  delete_serial_by_code(code,model) {

        if (confirm('هل انت متأكد؟'))
        {
            if (!model)
            {
                model='deleted'
            }
            $.get("<?php  echo url.'/'.$this->folder?>/delete_serial_by_code/"+code+"/"+model, function(data){

                console.log(data)
                if (data)
                {
                    table.draw();
                }
            })
        }return false;


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


<style>
    .list_serial {
        border-bottom: 1px solid #dfdfdf;
        position: relative;
    }
    .list_serial:last-child {
        border-bottom: 0;
    }

    .list_serial span {
        position: absolute;
        left: -20px;
        width: 20px;
        height: 20px;
        color: red;
        font-size: 19px;
        cursor: pointer;
    }
</style>





